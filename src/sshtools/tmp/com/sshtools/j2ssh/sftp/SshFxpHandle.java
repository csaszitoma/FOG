/*
 *  SSHTools - Java SSH2 API
 *
 *  Copyright (C) 2002 Lee David Painter.
 *
 *  This program is free software; you can redistribute it and/or
 *  modify it under the terms of the GNU Library General Public License
 *  as published by the Free Software Foundation; either version 2 of
 *  the License, or (at your option) any later version.
 *
 *  You may also distribute it and/or modify it under the terms of the
 *  Apache style J2SSH Software License. A copy of which should have
 *  been provided with the distribution.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  License document supplied with your distribution for more details.
 *
 */

package com.sshtools.j2ssh.sftp;

import com.sshtools.j2ssh.io.ByteArrayReader;
import com.sshtools.j2ssh.io.ByteArrayWriter;
import com.sshtools.j2ssh.io.UnsignedInteger32;
import com.sshtools.j2ssh.subsystem.SubsystemMessage;

/**
 *
 *
 * @author $author$
 * @version $Revision: 1.1.1.1 $
 */
public class SshFxpHandle
    extends SubsystemMessage
    implements MessageRequestId {
  /**  */
  public static final int SSH_FXP_HANDLE = 102;
  private UnsignedInteger32 id;
  private byte[] handle;

  /**
   * Creates a new SshFxpHandle object.
   *
   * @param id
   * @param handle
   */
  public SshFxpHandle(UnsignedInteger32 id, byte[] handle) {
    super(SSH_FXP_HANDLE);
    this.id = id;
    this.handle = handle;
  }

  /**
   * Creates a new SshFxpHandle object.
   */
  public SshFxpHandle() {
    super(SSH_FXP_HANDLE);
  }

  /**
   *
   *
   * @return
   */
  public UnsignedInteger32 getId() {
    return id;
  }

  /**
   *
   *
   * @return
   */
  public byte[] getHandle() {
    return handle;
  }

  /**
   *
   *
   * @param bar
   *
   * @throws java.io.IOException
   * @throws com.sshtools.j2ssh.transport.InvalidMessageException DOCUMENT
   *         ME!
   */
  public void constructMessage(ByteArrayReader bar) throws java.io.IOException,
      com.sshtools.j2ssh.transport.InvalidMessageException {
    id = bar.readUINT32();
    handle = bar.readBinaryString();
  }

  /**
   *
   *
   * @return
   */
  public String getMessageName() {
    return "SSH_FXP_HANDLE";
  }

  /**
   *
   *
   * @param baw
   *
   * @throws java.io.IOException
   * @throws com.sshtools.j2ssh.transport.InvalidMessageException DOCUMENT
   *         ME!
   */
  public void constructByteArray(ByteArrayWriter baw) throws java.io.
      IOException,
      com.sshtools.j2ssh.transport.InvalidMessageException {
    baw.writeUINT32(id);
    baw.writeBinaryString(handle);
  }
}
